@extends('layouts.theme.app')
@section('content')
<section id="subintro">
    <div class="jumbotron subhead" id="overview">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="centered">
              <h3>404</h3>
              <p>
                Page Not Found
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="breadcrumb">
    <div class="container">
      <div class="row">
        <div class="span12">
          <ul class="breadcrumb notop">
            <li><a href="{{url('/')}}">Home</a><span class="divider">/</span></li>
            <li class="active">error</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="centered">
            <h2 class="error">404</h2>
            <h3>Sorry, that page doesn't exist!</h3>
            <p>
              The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection