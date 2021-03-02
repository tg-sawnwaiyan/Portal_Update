
<template>
    <layout>
        <div class="gcse-searchresults"></div>
</layout>
</template>


<script>
export default {

     

      updated() {
          console.log($(".gsc-results-wrapper-visible").length);
          if ($(".gsc-results-wrapper-visible").length){
   $('.menu_category').css('display','none')
}
            ;
        }
        }
        
</script>