@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection

@section('content')
	<b-container>
		<b-alert :show="showNoRacesMessage" variant="warning">No races found</b-alert>

		<b-alert variant="danger"
			dismissible
			:show="showError"
			@dismissed="showError = false">
			@{{ errorMessage }}
		</b-alert>

		<b-row v-if="showLoader">
            <b-col md="5" offset-md="5">
				<breeding-rhombus-spinner
			      :size="150"
			      color="#3097d1"
			    />
			</b-col>
		</b-row>

        <b-row v-if="showRacesList">
            <b-col md="8" offset-md="2">
            	<b-card>
					<b-table striped hover :items="racesList" :fields="raceFields" :responsive="true">
						<template slot="close_time" slot-scope="data">
							<countdown v-on:countdown-expired="removeRaceAndLoadNext5(data.item.id)" :date="data.item.close_time"></countdown>
						</template>
						<template slot="actions" slot-scope="data">
							<b-button size="sm" @click="onRaceClick(data.item.id, $event)">Competitors</b-button>
						</template>
					</b-table>
				</b-card>
            </b-col>
        </b-row>

        <b-row v-if="showSingleRaceDetails" style="margin-bottom: 20px;">
        	<b-col md="5" offset-md="5">
        		<b-button @click.prevent="goBack()">Back to races list</b-button>
        	</b-col>
        </b-row>
        
        <b-row v-if="showSingleRaceDetails">
            <b-col md="8" offset-md="2">
            	<b-card>
					<b-card-body>
						<div class="d-flex w-100 justify-content-between">
							<h4 class="mb-1">@{{ race.name }}</h4>
							<countdown v-on:countdown-expired="goBack(); displayErrorMessage('The race you were looking at is now closed');" :date="race.close_time"></countdown>
						</div>
						<p class="mb-1">
							Location: <strong>@{{ race.meeting.location }}</strong>
						</p>
						<small>
							Type: <strong>@{{ race.meeting.type }}</strong>
						</small>
					</b-card-body>
					<b-table striped :items="race.competitors" :fields="competitorFields"></b-table>
				</b-card>
            </b-col>
        </b-row>
    </b-container>
@endsection