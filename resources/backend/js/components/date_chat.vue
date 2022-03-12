

<template>

    <div class="date_messages">
        {{ f_show_date(datem,next,i)  }}
    </div>

</template>


<script>
    import moment from 'moment';
    export default {

        name: "comp",
        props: ['datem','next','i'],
        data() {
            return {

            }

        },
        methods: {

            f_show_date(date, next,i) {
                let messageOld = moment(date.created_at);
                let new_date = moment(next.created_at).format('YYYY-MM-DD');
                if (messageOld.format('YYYY-MM-DD') !== new_date) {

                    let messageNew = new Date(new_date);
                    let diff = moment().diff(messageNew, 'days');

                    if (diff === 1) {
                        return 'Today';
                    } else if (diff === 2) {
                        return "Yesterday"
                    } else if (diff > 2 && diff < 8) {
                        return moment(messageOld).format('dddd');
                    } else {
                        return moment(messageOld).format('MM/DD/YYYY');
                    }
                } else {
                 {
                        return '';
                    }

                }
            },

        }


    }

</script>

<style type="text/css" scoped>


    .date_messages {
        font-size: 14px;
        text-align: center;
        width: fit-content;
        margin: auto;
        padding-bottom: 10px;

    }


</style>