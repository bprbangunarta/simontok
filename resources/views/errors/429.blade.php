@extends('errors.layout')
@section('title', '429 Too Many Requests')
@section('error_code', '429')

@section('error_message')
Permintaan Anda tidak dapat diproses karena terlalu banyak permintaan dalam waktu singkat. Coba lagi nanti.
@endsection