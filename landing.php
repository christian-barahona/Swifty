<nav class="navbar navbar-toggleable-md navbar-light bg-faded" id="main-nav">
    <button class="navbar-toggler navbar-toggler-right hidden-print" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="?">
        <img src="assets/ucb_logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Departures
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="?p=view_all">View All</a>
            <a class="nav-item nav-link" href="?p=new_entry">New Entry</a>
        </div>
    </div>
</nav>

<style>
    html {
        background: url('assets/landing_page_50.jpg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    #main-nav {
        display: none;
    }
</style>

<div class="d-flex justify-content-center align-self-center" id="landing-page-buttons">
    <div class="card" id="logo">
        <img class="d-flex justify-content-center align-self-center" src="assets/ucb_logo_lg.png" height="200" width="200" alt="UCB Logo">
        <div class="card-body">
            <h1 class="card-title display-4 text-center">Swifty</h1><br>
            <p><button type="button" class="btn btn-outline-success btn-lg btn-block" id="landing-new-hires-button">New Hires</button></p>
            <p><button type="button" class="btn btn-outline-success btn-lg btn-block" id="landing-departures-button">Departures</button></p>
        </div>
        </div>
</div>