@extends('layouts.app')


@section('content')
    @guest
        <div class="flex-center position-ref heightcontainer">
            <div class="content">
                <div class="title m-b-md">
                    en0 Upload
                </div>
                <div class="links">
                    <a href="/login/gitlab">log in</a>
                </div>
            </div>
        </div>
    @endguest
    @auth
        <div class="row">
            <div class="card col-md-4 d-flex align-items-stretch">
                <div class="card-header">
                    Uploader
                </div>
                <div class="card-body">
                    <form id="uploader" action="/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="filetoupload" multiple="multiple">
                        <div class="form-group">
                            <label class="form-group-label" for="expirytime">File expiry time</label>
                            <select name="expirytime" id="expirytime">
                                <option value="30">30 seconds</option>
                                <option value="3600">1 hour</option>
                                <option value="14400">4 hours</option>
                                <option value="43200">12 hours</option>
                                <option value="86400">24 hours</option>
                                <option value="172800">48 hours</option>
                                <option value="259200">72 hours</option>
                                <option value="604800">7 days</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-group-label" for="maxdownloads">Maximum Downloads</label>
                            <input type="number" max="100" min="1" name="maxdownloads" id="max-ownloads" value="10">
                        </div>
                        <div class="progress" id="upload-progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <input type="submit">
                        <p id="uploadStatus"></p>
                    </form>
                </div>
            </div>
            <div class="card col-md-8 d-flex align-items-stretch">
                <div class="card-header">
                    Files
                </div>
                <div class="card-body">
                    <table class="table-bordered">
                        <thead>
                        <tr>
                            <td>Filename</td>
                            <td>Expiry</td>
                            <td>Downloads left</td>
                            <td>Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Files as $File)

                            <tr>
                                <td>{{$File->filename}}</td>
                                <td class="time-to-moment">{{$File->expires_at}}</td>
                                <td>{{$File->remaining_downloads}}</td>
                                <td>
                                    <i class="bi bi-clipboard copylink"
                                       data-url="{{route('downloadpage', ['fileuuid' => $File->file_uuid,'filekey'=>$File->download_key])}}"></i>
                                    <a onclick="return confirm('Are you sure?')"
                                       href="{{URL::signedRoute('userDeleteFile', ['fileuuid' => $File->file_uuid])}}"><i
                                            class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>




    @endauth
@endsection
