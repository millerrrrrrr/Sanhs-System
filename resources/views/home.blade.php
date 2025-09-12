@extends('layout')
@section('title', 'Home')
@section('pagetitle', 'Dashboard')

@section('main')
    
{{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow-md border border-[#e5e7eb]">
        <h2 class="text-lg font-semibold text-[#3b38a0] ">Date Started Learning Laravel</h2>
        <p class="text-[#7a85c1 mt-2]">July 17, 2025</p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-[#e5e7eb]">
        <h2 class="text-lg font-semibold text-[#3b38a0] ">Greetings</h2>
        <p class="text-[#7a85c1 mt-2]">Hello,</p>

    </div>



</div> --}}
    
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">


    <div class="bg-white p-6 rounded-2xl shadow-md border border-[#e5e7eb]">
        <h2 class="text-lg font-semibold ">Number of Registered Students</h2>

            <p class="text-[#7a85c1 mt-2]"> {{ $numberOfStudents }} </p>
      
    </div>

  



</div>


<div class="page mt-4 ">
    <h2 class="title">Display Title </h2>
    <p class="p">Helllo</p>
</div>




@endsection