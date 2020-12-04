<template>
<layout>
    <div>
        <div class="card w-h">
            <div class="card-body text-center">
                <span class="text-style">Server Maintenance</span>
            </div>
        </div>
    </div>
</layout>
</template>   
<style scoped>
.w-h {
    width: 100%;
    height: 500px;
}
.card{
    background-color: #d5d5d5;
    margin-left:5px;
    margin-right:5px;
    margin-top:-10px;
    margin-bottom:-10px;
}
.text-center{
    text-align: center !important;
    display: flex;
    justify-content: center;
    align-items: center;
    }
.text-style{
    font-size: 8em;
    font-weight: bold;
    color:#2980b9;
    text-shadow: 1px 1px 2px #393939;
}
@media only screen and (max-width:480px) {    
   .w-h{
        height: 380px;
   }
}
</style>