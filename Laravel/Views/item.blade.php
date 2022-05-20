<?php
/**
* @var $page Src\JsonObjects\Interfaces\Pages\IItem
**/
?>

@extends('common::adminLayout')

@section('title', $page->getTitle())

@section('sideBar')
    @include('common::parts.sideBar', ['sidebar' => $page->getSidebar()])
@endsection

@section('breadcrumbs')
    @include('common::parts.breadcrumbs', ['breadcrumbs' => $page->getBreadcrumbs()])
@endsection

@section('content')
    <section class="content js-content">
        <div class="col-md-12">
            <div class="box box-success js-box">
                <div class="box-header with-border">
                    <h3 class="box-title js-box-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                        </svg>
                        JSON Objects
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool js-collapse-button" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body js-box-body">
                    <div class="js-app-container">
                        <div class="col-sm-12 col-lg-6 col-xl-3">
                            <label class="form-label">Key</label>
                            <input type="text" class="form-control js-key-input" {{ ($page->getItem()->isDisabled()) ? 'disabled' : '' }}>
                            <div class="invalid-feedback js-key-error-message"></div>
                        </div>

                        <div class="js-object-form-container object-form-container col-sm-12 col-lg-6 col-xl-3"></div>

                        <div class="col-sm-12 col-lg-6 col-xl-3">
                            <button class="btn btn-info js-submit-button">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var settings = {!! json_encode($page->getJsSettings()) !!};
        var commonSettings = {!! json_encode($page->getCommonJsSettings()) !!};
    </script>
    @foreach($page->getJsStack() as $jsScript)
        {!! $jsScript !!}
    @endforeach
@endpush

@push('styles')
    @foreach($page->getCssStack() as $css)
        {!! $css !!}
    @endforeach
@endpush