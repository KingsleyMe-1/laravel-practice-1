@if (session()->has('message'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show" class="fixed top-0 left-1/2 -translate-x-1/2 transform text-white px-48 py-3 bg-green-700">
        {{session('message')}}
    </div>
@endif