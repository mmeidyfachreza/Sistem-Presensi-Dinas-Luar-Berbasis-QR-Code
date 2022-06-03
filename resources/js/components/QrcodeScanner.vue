<template>
    <div v-show="this.presenceStore.show" class="col-md-8">
            <div class="card">
                <div class="card-header">Presensi Dinas Keluar</div>

                <div class="card-body">
                    <transition name="fade">
                        <div v-if="lokasi">
                            <!-- <qrcode-stream @decode="onDecode" @init="onInit" /> -->
                            <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">
                            <div v-show="showScanConfirmation" class="scan-confirmation">
                                <img :src="'/img/checkmark.svg'" alt="Checkmark" width="128px" />
                            </div>
                            </qrcode-stream>
                        </div>
                        <div v-else>
                            <p>Pastikan anda mengizinkan akses lokasi untuk kelengkapan data presensi</p>
                        </div>
                    </transition>

                </div>
            </div>
        </div>
</template>

<script>
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader';
import { usePresenceStore } from '../store/presenceStore';
import { mapStores } from 'pinia';

    export default {
        computed: {
        // note we are not passing an array, just one store after the other
        // each store will be accessible as its id + 'Store'
        ...mapStores(usePresenceStore)
        },
        components: {
            QrcodeStream,
            QrcodeDropZone,
            QrcodeCapture,
        },
        data () {
            return {
            result: '',
            status: '',
            error: '',
            pesan: 'gagal',
            loading: true,
            location:null,
            gettingLocation: false,
            errorStr:null,
            show: true,
            lokasi: false,
            ada: false,
            camera: 'auto',
            showScanConfirmation: false
            }
        },
        methods: {
            async onInit (promise) {
            try {
                await promise
            } catch (e) {
                console.error(e)
            } finally {
                this.showScanConfirmation = this.camera === "off"
            }
            },
            async onDecode (decodedString) {
                this.$getLocation()
                .then(coordinates => {
                    axios.post('/api/presensi/verif-qrcode',{
                        qrcode: decodedString,
                        userId: this.presenceStore.userId,
                        lat: coordinates.lat,
                        long: coordinates.lng
                    }).then(response => {
                        // this.status = response.data.hasil
                        // this.show = !response.data.hasil
                        // this.loading = false
                        // this.pesan = response.data.pesan
                        console.log(response)
                        if(response.data.status=='hadir'){
                            this.presenceStore.startTime = response.data.time
                        }else{
                            this.presenceStore.endTime = response.data.time
                            this.presenceStore.show = response.data.show
                        }
                        // v.qr = response.data.data[0].qrcode;
                    });
                });
                this.pause()
                await this.timeout(500)
                this.unpause()
            },
            unpause () {
                this.camera = 'auto'
            },

            pause () {
                this.camera = 'off'
            },

            timeout (ms) {
                return new Promise(resolve => {
                    window.setTimeout(resolve, ms)
                })
            }

        },
        mounted(){
            this.$getLocation()
            .then(coordinates => {
                this.lokasi = true;
            }).catch(error => {
                this.$swal({
                title: 'Error!',
                text: 'Presensi tidak bisa dilakukan tanpa akses lokasi',
                icon: 'error',
                confirmButtonText: 'Ok'
                });
            });
        }
    }
</script>
<style scoped>
.scan-confirmation {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, .8);

  display: flex;
  flex-flow: row nowrap;
  justify-content: center;
}
</style>
