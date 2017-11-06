 @extends('layouts.app') @section('content')
<div class="col-sm-8 col-md-offset-2 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4 heading color-black">Add Slider</div>
                <div class="col-md-8 text-right">
                    <a href='{{ url("slider") }}' class="btn btn-default color-black">List of Sliders</a>
                </div>
            </div>
        </div>
        <form method="POST" action="/slider/{{$slider->id}}" enctype="multipart/form-data" id="multiple_upload_form">
            {{ csrf_field() }} {{ method_field('PUT') }}
            <div class="panel-body">
                <div class="form-group">
                    <label class="color-black">Slider Name </label>
                    <input type="text" name="name" class="form-control" id="sliderName" value="{{ $slider->name}}">
                </div>
                <div class="form-group">
                    <label class="color-black"> Slider Type </label>
                    <select name="slider_type" class="form-control color-black">
                        <option value="banner">Banner</option>
                        <option value="slider">Slider</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="color-black">Auto play </label>
                    <select class="form-control color-black" name="auto_play">
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="color-black"> Slides Per Page</label>
                    <input type="text" name="slides_per_page" class="form-control" value="{{ $slider->slides_per_page}}">
                </div>
                <div class="form-group">
                    <label class="color-black"> Slider Width (%)</label>
                    <input type="text" name="slider_width" class="form-control" value="{{ $slider->slider_width}}">
                </div>
                <div class="form-group">
                    <label class="color-black"> Slider Height (%)</label>
                    <input type="text" name="slider_height" class="form-control" value="{{ $slider->slider_height}}">
                </div>
                <div class="form-group">
                    <label class="color-black">Images</label>
                    <input type="file" name="image_name[]" class="form-control" id="gallery-photo-add" multiple/>
                </div>
                <div class="col-sm-12">
                    @foreach($slider['slides'] as $imageKey => $slide)
                    <div class="col-sm-3">
                        <img src="{{ asset('storage/'.$slider->name.'/original/'.$slide->image_name)}}" class="img img-thumbnail" name="image_name" style="width: 100%; height: 130px;">
                        <div class="image-action" onclick="removeImage(this)"><a class="btn btn-danger btn-sm"> X </a></div>
                        <input type="hidden" name="oldSlides[{{$imageKey}}][image_name]" value="{{ $slide->image_name }}">
                        <input type="hidden" name="oldSlides[{{$imageKey}}][id]" value="{{ $slide->id }}">
                        <label class="color-black">Start Date</label>
                        <input type="date" name="oldSlides[{{$imageKey}}][start_date]" class="form-control" value="{{ date('Y-m-d', strtotime($slide->start_date)) }}">
                        <label class="color-black">End Date</label>
                        <input type="date" name="oldSlides[{{$imageKey}}][end_date]" class="form-control" value="{{ date('Y-m-d', strtotime($slide->end_date)) }}">
                        <label>Title</label>
                        <input type="text" name="oldSlides[{{$imageKey}}][title]" class="form-control" value="{{ $slide->title }}">
                        <label>Description</label>
                        <input type="text" name="oldSlides[{{$imageKey}}][description]" class="form-control" value="{{ $slide->description }}">

                        <label class="color-black">Is Active</lable>
                            <input type="checkbox" class="form-control" name="oldSlides[{{$imageKey}}][is_active]" value="1" @if ($slide->is_active == 1) checked @endif>
                    </div>
                    @endforeach
                    <div class="row" id="gallery">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function removeImage(id) {
    $(id).parent().remove();
}

$(function() {

    // Variable to store your files
    var files;
    var text;
    var startDate;
    var sliderName;

    // Add events
    $('input[type=file]').on('change', function(event) {
        files = event.target.files;


        // Create a formdata object and add the files
        var data = new FormData();



        $.each(files, function(key, value) {
            data.append(key, value);
        });



        $sliderImageRequest = $.ajax({
            url: '/slides/preview',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a
        });

        $sliderImageRequest.then(function(response) {
            $("#gallery").html(response);

        });

    });
});
</script>
@endsection