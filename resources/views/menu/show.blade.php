<x-header>
    @section('title', 'Menu')
</x-header>
@if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif
<style>
    .content {
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        gap: 1.5rem;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        --tw-text-opacity: 1;
        color: rgb(203 213 225 / var(--tw-text-opacity));
    }

    .img {
        display: block;
        vertical-align: middle;
        width: 50%;
        border-radius: 10%;
        margin: auto;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        font-size: 100%;
        font-weight: inherit;
        line-height: inherit;
        color: inherit;
        margin: 0;
        padding: 0;
    }
</style>

<div style="height:150px;"></div>
<div class="content">
    <div>
        <h1 style="font-size:60px">{{ $data->name }}</h1>
    </div>
    <div style="filter:drop-shadow(-1px 3px 4px #fcb3b3)">
        <img src="{{ asset($data->image) }}" alt="" class="img-fluid img">
    </div>
    <div class="col-lg-6 details items-center text-center ">
        <p class=" text-xl my-2">{{ $data->description }}</p>
        <p class="mt-6">Price: ${{ $data->price }}</p>
    </div>

    <form action="{{ route('cart.update', $data->id) }}" method="post" style="text-align: center;" class="mb-3">
        @csrf
        @method('PUT')
        <div><input type="number" name="quantity" min="1" placeholder="Quantity"
                style="color:black;border-radius:5%" value="{{ $quantity }}"></div>
        <div><input type="submit" value="add to cart" class="my-3"
                style="border:1px solid #fcb3b3; border-radius:5%; padding: 3%; background-color:#fcb3b3; color:#000;">
        </div>
    </form>

</div>
<div>
</div>
            
<form action="{{ route('review' ) }}" method="POST"> 
    @csrf
    <input type="text" name="name"  placeholder="Your Name" required>
    <input type="hidden" name="meal_id"   value="{{ $data->id }}" >
    <textarea  name="comment" rows="5" placeholder="comment"  required></textarea>
    <input type="number" name="rating" min="1" max="5" required>
   <button type="submit">add review</button>
</form>

</div>
<div>
    <ul>
  @foreach($info as $review)
  <li>
  <p>{{ $review->name }}</p>
  <h2>-----{{ $review->rating}}/5-----</h2>
  <p>{{ $review->comment }}</p>
  </li>
  @endforeach  
    </ul>
</div>

<x-footer />
