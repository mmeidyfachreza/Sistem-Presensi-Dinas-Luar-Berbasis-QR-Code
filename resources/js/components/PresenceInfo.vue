<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Presensi Dinas Keluar</div>

            <div class="card-body">
                <table class="table info">
                    <tbody>
                        <tr>
                            <td class="label">Waktu Hadir</td>
                            <td>:</td>
                            <td>{{presenceStore.startTime}}</td>
                        </tr>
                        <tr>
                            <td class="label">Waktu Pulang</td>
                            <td>:</td>
                            <td>{{presenceStore.endTime}}</td>
                        </tr>
                        <tr>
                            <td class="label">Durasi Kerja</td>
                            <td>:</td>
                            <td>{{presenceStore.result}}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <div class="row">
                    <a :href="linkV" v-if="!jam_hadir" class="col-lg-6 btn btn-info">Presensi Hadir</a>
                    <a :href="linkV" v-if="!jam_pulang&&jam_hadir" class="col-lg-6 btn btn-success">Presensi Pulang {{jam_pulang}}</a>
                    <p v-if="jam_pulang&&jam_hadir" class="px-4">Anda sudah melakukan presensi hari ini, selamat beristirahat</p>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>

import { usePresenceStore } from '../store/presenceStore'
import { mapStores } from 'pinia'

export default {
    computed: {
    // note we are not passing an array, just one store after the other
    // each store will be accessible as its id + 'Store'
    ...mapStores(usePresenceStore)
    },
    mounted(){
        console.log(this.presenceStore.startTime)
        console.log(this.presenceStore.endTime)
    }
}
</script>
<style>
.info td.label{
    width: 40%;
}
</style>
