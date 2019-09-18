@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @guest
                <v-banner single-line elevation="4">
                    <v-icon
                        slot="icon"
                        color="warning"
                    >
                        mdi-cogs
                    </v-icon>
                    <b>Inicie session para gestionar los tickets</b>
                </v-banner>
            @endguest
            <router-view></router-view>
        </div>
    </div>
</div>
@endsection
