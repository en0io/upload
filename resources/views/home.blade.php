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
                            <div
                                class="progress-bar progress-bar-striped text-center text-dark bg-success font-weight-bold"
                                role="progressbar" style="width: 0%"
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
                    @if($Files->count())

                        <table class="table-bordered">
                            <thead>
                            <tr>
                                <td>Filename</td>
                                <td>Expires</td>
                                <td>Downloads left</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Files as $File)
                                <tr>
                                    <td>{{$File->filename}} <span class="text-right"> ({{round($File->filesize/1000/1000,2)}} MB)</span>
                                    </td>
                                    <td class="time-to-moment">{{Carbon\Carbon::parse($File->expires_at)->diffForHumans();}}</td>
                                    <td>{{$File->remaining_downloads}}</td>
                                    <td>
                                        <i class="bi bi-clipboard copylink" title="click to copy download URL"
                                           data-filename="{{$File->filename}}"
                                           data-url="{{route('downloadpage', ['fileuuid' => $File->file_uuid,'filekey'=>$File->download_key])}}
                                               "></i>
                                        <a class="action-delete-file"
                                           href="{{URL::signedRoute('userDeleteFile', ['fileuuid' => $File->file_uuid])}}"
                                           data-filename="{{$File->filename}}"><i
                                                class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You have no files.</p>
                    @endif
                </div>
            </div>
        </div>
        <div style="position: absolute; top: 3rem; right: 0;">
            <div class="toast bg-secondary target-copynotification-toast" role="alert" aria-live="assertive"
                 aria-atomic="true" data-delay="1500">
                <div class="toast-header">
                    <i class="bi bi-clipboard-check"></i>
                    <strong class="mr-auto">Copied!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Copied the download link for <span class="target-copynotification-filename">null</span>
                </div>
            </div>
        </div>
    @endauth
@endsection
