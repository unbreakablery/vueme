<template>
  <div class="model-replays">
    <h1 class="title">Replays</h1>
    <div class="replays-list">
          <div class="replays-data">
            <div class="d-flex">
               <span>Currently Empty</span>
            </div>
          </div>

   <!--   
      <div class="replays-data">
        <div class="d-flex">
          <div>
            <img class="replays-img" :src="'/images/models/newmodel.png'" alt="">
          </div>
          <div class="replays-content">
            <h2 class="content-title">Content name goes here</h2>
            <div class="d-flex-center">
              <span class="membership mr-4">Monthly</span>
              <div class="d-flex quick-group">
                <span class="quick"><img class="img-quick" :src="'/images/icons/model-calendar.svg'" alt=""><h6>05/04</h6></span>
                <span class="quick"><img class="img-quick" :src="'/images/icons/model-heart.svg'" alt=""><h6>0</h6></span>
                <span class="quick"><img class="img-quick" :src="'/images/icons/model-eye.svg'" alt=""><h6>0</h6></span>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex align-center">
          <a href="#"><img class="img-quick" :src="'/images/icons/model-edit.svg'" alt=""></a>
        </div>
      </div>
-->



    </div>
  </div>
</template>

<script>
export default {
  setup() {
    
  },
}
</script>

<style lang="scss">



.model-replays {
  max-width: 1010px;
  padding: 48px 40px;
  .title {
    font-size: 24px!important;
    color: #42424D;
    font-family: "Montserrat", sans-serif !important;
    margin-bottom: 20px;
  }
  .d-flex-center {
    display: flex;
    align-items: center;
  }
  .replays-list {
    max-width: 588px;
    .replays-data {
      min-height: 104px;
      background-color: white;
      padding: 12px 40px;
      display: flex;
      background-color: #f4f4f4;
      padding: 40px 40px;
      display: flex;
      color: #c7c7c7;
      justify-content: space-between;
    }
    .replays-img {
      max-width: 80px;
      height: 80px;
    }
    .replays-content {
      margin-left: 16px;
      display: flex;
      flex-flow: column;
      justify-content: center;
      .content-title {
        font-family: "Montserrat", sans-serif !important;
        font-weight: bold;
        color: #131220;
        font-size: 18px;
        margin-bottom: 5px;
        margin-top: 5px;
      }
      .membership {
        color: #F77F98;
        font-size: 12px;
        font-family: "Montserrat", sans-serif !important;
        font-weight: bold;
      }
      .quick-group {
        margin: 5px 0;
      }
      .quick {
        margin-right: 10px;
        display: flex;
        align-items: center;
        h6 {
          font-size: 11px;
          color: #949498;
          margin-bottom: 0px;
          font-weight: 600;
        }
      }
      .img-quick {
        margin-right: 3px;
      }
    }
  }
}
@media (max-width: 521px) {
  .model-replays {
    padding-left: 0px;
    padding-right: 0px;
    .title {
      margin-left: 20px;
      font-size: 20px!important;
    }
    .replays-data {
      padding-left: 20px!important;
      padding-right: 20px!important;
    }
    .replays-content {
      display: block!important;
      .content-title {
        font-size: 16px!important;
        margin-top: 0px!important;
        margin-bottom: 0px!important;
      }
      .d-flex-center {
        display: block;
        .quick-group {
          margin: 0px;
          .quick {
            flex-flow: column;
            .img-quick {
              width: 24px;
              height: 24px;
              margin-right: 0px;
            }
          }
        }
      }
    }
  }
  
}
</style>