<template>


    <pre>{{ xmlContent }}</pre>


</template>

<script>
export default {
         data () {
    return {
      xmlContent: null,
    };
  },
        created () {
    this.loadData();
  },
  methods: {
    loadData () {
      this.xmlContent = null;
      this.xmlError = false;
      this.axios.get('/api/sitemap').then(response => {
          if(response.status == 200){
               this.axios.get('../sitemap.xml').then(response => {
        this.xmlContent = response.data;
      }, () => {
        this.xmlError = true;
      });
          }
      }, () => {
        this.xmlError = true;
      });
    }
  }
}
</script>