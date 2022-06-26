<template>
    <div class="row justify-content-center">
        <PresenceInfo/>
        <QrcodeScanner/>
    </div>
</template>

<script>
import QrcodeScanner from './QrcodeScanner';
import PresenceInfo from './PresenceInfo.vue';
import { usePresenceStore } from '../store/presenceStore'
import { mapStores } from 'pinia';

    export default {
        props: ['projectId'],
        computed: {
        // note we are not passing an array, just one store after the other
        // each store will be accessible as its id + 'Store'
        ...mapStores(usePresenceStore)
        },
        data()
        {
            return{
                user_id: this.$userId,
            }
        },
        components: {
            PresenceInfo,
            QrcodeScanner,
        },
        created(){
            this.id = this.projectId
            this.presenceStore.userId = this.user_id
            this.presenceStore.pause()
            this.presenceStore.show = false
            axios
            .get('/api/presensi/'+this.user_id+'')
            .then(response => {
                this.presenceStore.startTime = response.data.startTime
                this.presenceStore.endTime = response.data.endTime
                this.presenceStore.workDuration = response.data.work_duration
                // this.durasi = response.data.data.durasi_kerja
                // console.log(this.jam_hadir);
                //this.linkLoc ='https://www.google.com/maps/place/'+response.data.latitude+','+response.data.longitude
            });

        },
    }
</script>
