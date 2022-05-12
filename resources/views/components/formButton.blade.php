<form action={{$route}} method={{strtoupper($method)}}>
    @csrf
    @if (isset($methodChanger))
        @method(strtoupper($methodChanger))
    @endif
    <input
    class="bg-{{$buttonColor}}-500 hover:bg-{{$buttonColor}}-400 text-white font-bold py-2 px-4 border-b-4 border-{{$buttonColor}}-700 hover:border-{{$buttonColor}}-500 rounded"
    type="submit" value="{{$inputValue}}">
</form>
