
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import {BreedingRhombusSpinner} from 'epic-spinners';
import Countdown from './components/Countdown.vue';

window.next5App = new Vue({
	el: '#app',

	components: {
        axios, BreedingRhombusSpinner, Countdown
    },

    data: function() {
        return {
        	/**
        	 * A list of race objects.
        	 * @type {Array}
        	 */
            races: [],
            /**
             * A single race object. Used when the user click on a race to see its details
             * @type {Object}
             */
            race: null,
            /**
             * Loading status
             * @type {Boolean}
             */
            loading: false,
            /**
             * Whether or not a loader should be displayed
             * @type {Boolean}
             */
            showLoader: false,
            /**
             * If true show an alert containing an error message
             * @type {Boolean}
             */
            showError: false,
            /**
             * The error message displayed by the alert
             * @type {String}
             */
			errorMessage: 'An error occurred, try reloading the page please.',
			/**
			 * The list of fields displayed by the races table component
			 * @type {Array}
			 */
			raceFields: [
				{
					key: 'race_name',
					sortable: false
		        },
		        {
					key: 'location',
					sortable: false
		        },
		        {
					key: 'type',
					sortable: false
		        },
		        {
					key: 'close_time',
					sortable: false
		        },
		        {
					key: 'actions',
					label: '',
					sortable: false
		        }
			],
			/**
			 * The list of fields displayed by the competitors table component
			 * @type {Array}
			 */
			competitorFields: [
				{
					key: 'name',
					label: 'Competitor Name',
					sortable: false
		        },
		        {
					key: 'position',
					sortable: false
		        }
			]
        }
    },

    computed: {
    	/**
    	 * Transform the list of race objects in a list suitable for the races table component
    	 * @return {Array}
    	 */
    	racesList: function() {
    		let racesList = [];
    		for(let i in this.races) {
                if(!this.races.hasOwnProperty(i)) {
                    continue;
                }

                racesList.push({
                	id: this.races[i].id,
                	race_name: this.races[i].name,
                	location: this.races[i].meeting.location,
                	type: this.races[i].meeting.type,
                	close_time: this.races[i].close_time,
                	countdown: this.races[i].countdown
                });
            }

            return racesList;
    	},
    	/**
    	 * Whether or not to show the 'No races' message
    	 * @return {Boolean}
    	 */
        showNoRacesMessage: function() {
            return this.races.length == 0 && !this.showLoader && !this.race;
        },
        /**
         * Whether or not to show the races list
         * @return {Boolean}
         */
        showRacesList: function() {
            return this.races.length > 0 && !this.showLoader && !this.race;
        },
        /**
         * Whether or not to show the 'single race details'
         * @return {Boolean}
         */
        showSingleRaceDetails: function() {
            return !this.showLoader && this.race;
        }
    },

    methods: {
    	/**
    	 * Show loader and call the server to get the next 5 races
    	 */
    	getNext5() {
    		this.showLoader = true;

    		this.loadNext5();
        },

        /**
         * Call the server to get the next 5 races
         */
        loadNext5() {
        	// If there is another ongoing request do nothing
        	if(this.loading) {
        		return;
        	}

        	var _this = this;

        	this.loading = true;

        	axios.get('/api/next5').then(response => {
                _this.races = response.data.data;
                
                _this.showLoader = false;
                _this.loading = false;

                //	Reload races list after 30 seconds but only if the list is empty otherwise the list will be reloaded every time
                //	a countdown expires
                if(_this.races.length == 0) {
	                setTimeout(function() {
	                	_this.loadNext5();
	                }, 30000);
	            }
            }).catch(error => {
                console.error(error);
                _this.showLoader = false;
                _this.loading = false;
            });
        },

        /**
         * This function is called when a countdown expires. Remove the closed race from the list and reload the 'next 5 races' list.
         * The closed race is removed manually beacause the call to the server to get the next 5 races list could take some time. In the meanwhile
         * the user would still be able to see the closed race.
         * @param  {Integer} race_id
         */
        removeRaceAndLoadNext5(race_id) {
        	this.races = _.remove(this.races, function(race) {
				return race.id != race_id;
			});

			this.loadNext5();
        },

        /**
         * Display race details and competitors list
         * @param  {Integer} race_id
         * @param  {Object} event   DOM event object
         */
        onRaceClick(race_id, event) {
        	event.preventDefault();

        	this.showLoader = true;
        	this.loading = true;

    		var _this = this;

            axios.get('/api/show/' + race_id).then(response => {
                _this.race = response.data.data;

                _this.showLoader = false;
                _this.loading = false;

                //	If the race on which the user clicked is no longer available don't show it but refresh the list page and show an error message
                if(!this.race) {
                	_this.goBack();
                	_this.displayErrorMessage("The race you selected is no longer available");
                }
            }).catch(error => {
                console.error(error);
                _this.showLoader = false;
                _this.loading = false;
            });
        },

        /**
         * Go back to the list of the next 5 races
         */
        goBack(message) {
        	this.race = null;

        	this.getNext5();
        },

        /**
         * Display an error message using an alert
         * @param  {String} message 
         */
        displayErrorMessage(message) {
        	this.errorMessage = message;
            this.showError = true;
        }
    },

    mounted: function() {
    	// Download the list of the next 5 races
        this.getNext5();
    }
});