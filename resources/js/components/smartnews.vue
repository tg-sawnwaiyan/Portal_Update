<template>

  
    <div><pre>{{ xmlContent }}</pre></div>
 

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

      this.axios.get('/xml/smartnews.xml').then(response => {
          console.log(response);
        this.xmlContent = response.data;
      }, () => {
        this.xmlError = true;
      });
    }
  }

}
</script>
<style scoped>
pre {
    overflow: hidden;
}
</style>
