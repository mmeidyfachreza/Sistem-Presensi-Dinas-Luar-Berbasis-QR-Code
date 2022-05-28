<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <qrcode-stream @decode="onDecode"></qrcode-stream>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader';

    export default {
        components: {
            QrcodeStream,
            QrcodeDropZone,
            QrcodeCapture
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            onDecode (decodedString) {
                console.log(decodedString)
            }
        }
    }
</script>
