<?php

namespace App\Http\Controllers;
use App\Enums\ReservationType;
use App\Enums\TableStatus;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\branch;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\TestingNotification;

class ReservationController extends Controller
{
    // View the Reservation forms and page
    public function viewReservation()
    {
        // Define min & max dates for the times of table reservation
        $min_date = Carbon::now();
        $max_date = Carbon::now()->addWeek();

        //Only available tables are shown
        $tables = Table::where('status', TableStatus::Available)->get();
        $branches = branch::all();

        return view('reservations', ['minDate' => $min_date, 'maxDate' => $max_date, 'tables' => $tables, 'branches' => $branches]);
    }

    // Add a reservation to the database
    public function addReservation(ReservationStoreRequest $req)
    {
        //Create a new reservation
        $reservation = new Reservation();
        $reservation->first_name = $req->first_name;
        $reservation->last_name = $req->last_name;
        $reservation->email = $req->email;
        $reservation->phone_number = $req->phone_number;
        $reservation->res_date = $req->res_date;
        $reservation->branch_id = $req->branch_id;
        $reservation->table_id = $req->table_id;
        $reservation->guest_number = $req->guest_number;
        $reservation->message = $req->message;

        // Tailor the input depending on the reservation type
        if (!isset($req->table_id)) {
            $reservation->type = ReservationType::Event;
        } else {

            $reservation->type = ReservationType::Table;

            // Guest number cannot be > than the table capacity
            $table  = Table::findOrFail($req->table_id);
            if ($req->guest_number > $table->guest_number)
                return back()->with('warning', 'Please choose the table based on the guests number');

            // Table should be the same as the chosen branch
            $table  = Table::findOrFail($req->table_id);
            if ($req->branch_id != $table->branch->id)
                return back()->with('warning', 'Please choose the table based on the branch');

            // Table reservation should be between opening hours
            $pickupDate = Carbon::parse($reservation->res_date);
            $pickupTime = Carbon::createFromTime($pickupDate->hour, $pickupDate->minute, $pickupDate->second);
            $earliestTime = Carbon::createFromTimeString("17:00:00");
            $lastTime = Carbon::createFromTimeString("23:00:00");
            if (!$pickupTime->between($earliestTime, $lastTime))
                return back()->with('warning', 'Time is outside openning hours (5:00pm to 11:00pm)');
        }

        // Table reservation should not be in the date of an event reservation
        $events = Reservation::where('type', ReservationType::Event)->get();
        $res_date = Carbon::parse($reservation->res_date)->format('Y-m-d');
        foreach ($events as $event) {
            $event_date = Carbon::parse($event->res_date)->format('Y-m-d');
            if ($res_date == $event_date && $reservation->branch_id == $event->branch_id) {
                return back()->with('warning', 'Restaurant is booked at this date, please choose another one');
            }
        }

        // save reservation
        $reservation->save();

        // Send notification to admin
        $data = branch::find($req->branch_id);
        $admin = User::where('user_type', 1)->get();
        foreach ($admin as $admin1) {
            if ($admin1) {
                $admin1->notify(new TestingNotification('Branch: ' . $data->name, 'new reservation has been made!'));
            }
        }

        return redirect(route('home.reservations'))->with('success', 'Reservation Complete');
    }
}
