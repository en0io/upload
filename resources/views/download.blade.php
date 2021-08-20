@extends('layouts.app')

@section('content')


    <a href="{{route('processdownload', ['fileuuid' => $File->file_uuid,'filekey'=>$File->download_key])}}"
       class="btn btn-primary btn-lg active" role="button" aria-pressed="true" onclick="$(this).attr('disabled')">Download {{$File->filename}}
        ({{round($File->filesize/1000/1000,2)}} MB)</a>

@endsection
