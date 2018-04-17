@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Show')
@section('content')

<div class = 'container'>
    <h1>
        Show videoalbum
    </h1>
    <form method = 'get' action = '{!!url("videoalbum")!!}'>
        <button class = 'btn blue'>videoalbum Index</button>
    </form>
    <table class = 'highlight bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>name : </i></b>
                </td>
                <td>{!!$videoalbum->name!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>description : </i></b>
                </td>
                <td>{!!$videoalbum->description!!}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection