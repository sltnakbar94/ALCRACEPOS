<template>
  <!-- @detected-condition fires when the connectivity status of the device changes -->
  <offline @detected-condition="handleConnectivityChange">
    <!-- Only renders when the device is online -->
    <div slot="online" v-html="onLine">
       {{ onLine }}
    </div>
    <!-- Only renders when the device is offline -->
    <div slot="offline" v-html="onLine">
      {{ onLine }}
    </div>
  </offline>
</template>
<script>
  import offline from 'v-offline';
    export default {
      components: {
        offline
      },
      data() {
        return {
            onLine: null,
            online: 'Online',
            offline: 'Offline',
          }
      },
      methods: {
        handleConnectivityChange(e) {
          console.log(e);
          this.onLine = e ? '<i class="fa fa-circle mr-1 text-success"></i> Online' : '<i class="fa fa-circle mr-1 text-danger"></i> Offline';
        }
    }
  }
</script>