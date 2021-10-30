@extends('errors::minimal')

@section('title', empty($exception->getMessage()) ? __('Not Found') : $exception->getMessage())
@section('code', '404')
@section('message', empty($exception->getMessage()) ? __('Not Found') : $exception->getMessage())
