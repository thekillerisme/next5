<template>
    <div :title="dateObject.format('DD/MM/YYYY HH:mm')">
        <div class="block">
            <p class="digit" v-if="days > 0">{{ days }}</p>
            <p class="text" v-if="days > 0">d</p>
        
            <p class="digit">{{ hours | two_digits }}</p>
            <p class="text">h</p>
        
            <p class="digit">{{ minutes | two_digits }}</p>
            <p class="text">m</p>
        
            <p class="digit">{{ seconds | two_digits }}</p>
            <p class="text">s</p>
        </div>
    </div>
</template>

<script>
    var moment = require('moment');

    export default {
        name: 'countdown',

        props: {
            date: {
                type: String,
                required: true
            }
        },

        filters: {
            // This filter pourpose is to always show two digits number (Eg.: 02 instead of 2)
            two_digits: function (value) {
                if(value.toString().length <= 1)
                {
                    return "0" + value.toString();
                }
                return value.toString();
            }
        },

        data: function() {
            return {
                now: moment()
            }
        },

        computed: {
            // Date string passed by the user become an instance of 'moment' date
            dateObject: function() {
                return moment(this.date, "YYYY-MM-DD HH:mm:ss");
            },

            // Diff between now and the date passed by the user
            diff: function() {
                return this.dateObject.diff(this.now);
            },

            seconds: function() {
                return moment.duration(this.diff).seconds();
            },

            minutes: function() {
                return moment.duration(this.diff).minutes();
            },

            hours: function() {
                return moment.duration(this.diff).hours();
            },

            days: function() {
                return moment.duration(this.diff).days();
            }
        },

        mounted() {
            this.$nextTick(function () {
                // Update countdown every second
                window.setInterval(() => {
                    this.now = moment();

                    if(this.diff <= 0) {
                        this.$emit('countdown-expired');
                    }
                }, 1000);
            });
        }
    }
</script>

<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:100);

    .block {
        display: flex;
        margin: 2px;
    }

    .text {
        color: #1abc9c;
        font-family: 'Roboto Condensed', serif;
        font-weight: 40;
        margin-top:2px;
        margin-bottom: 2px;
        text-align: center;
    }

    .digit {
        font-weight: 100;
        font-family: 'Roboto', serif;
        margin: 2px;
        text-align: center;
    }
</style>