<template>
  <div class="dialer-container">
    <div class="phone">
      <div class="screen">
        <div class="dialed-number">{{ dialedNumber }}</div>
      </div>
      <div class="keypad">
        <div class="keypad-row" v-for="row in keypadRows" :key="row">
          <button v-for="digit in row" :key="digit" @click="addToDialedNumber(digit)">{{ digit }}</button>
        </div>
        <div class="keypad-row">
          <button @click="backspace" class="backspace-button">&#9003;</button>
          <button @click="toggleModal" class="call-button" :disabled="isCalling || dialedNumber === '0'">Call</button>
        </div>
      </div>
    </div>
    
    <!-- Modal for Making Calls -->
    <div class="modal" v-if="showModal">
      <div class="modal-content">
        <h2>Calling {{ dialedNumber }}</h2>
        <button @click="endCall">End Call</button>
      </div>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      dialedNumber: "",
      callStatus: "Ready to Call",
      digits: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "*", "0", "#"],
      isCalling: false,
      showModal: false,
    };
  },
  computed: {
    keypadRows() {
      const rows = [];
      for (let i = 0; i < this.digits.length; i += 3) {
        rows.push(this.digits.slice(i, i + 3));
      }
      return rows;
    },
  },
  methods: {
    addToDialedNumber(digit) {
      this.dialedNumber += digit;
    },
    backspace() {
      this.dialedNumber = this.dialedNumber.slice(0, -1);
    },
    toggleModal() {
      if (!this.showModal) {
        this.showModal = true;
      } else {
        this.endCall();
      }
    },
    endCall() {
      this.isCalling = false;
      this.showModal = false;
      this.callStatus = "Call Ended";
      this.dialedNumber = "";
    },
  },
};
</script>

<style scoped>
/* Dialer Styles */
.dialer-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.phone {
  background-color: #333;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  padding: 20px;
  width: 300px;
  color: black;
}

.screen {
  background-color: #fff;
  border-radius: 5px;
  padding: 10px;
  text-align: right;
  font-size: 24px;
  min-height: 40px;
  margin-bottom: 10px;
  overflow: auto;
}

.dialed-number {
  font-size: 32px;
}

.call-status {
  font-size: 18px;
  color: #4c6580;
  text-transform: uppercase;
  margin-bottom: 10px;
}

.keypad {
  display: flex;
  flex-direction: column;
}

.keypad-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

button {
  flex: 1;
  height: 60px;
  font-size: 24px;
  margin: 0 5px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  background-color: #007bff;
  color: #fff;
  transition: background-color 0.2s, color 0.2s;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

button:hover {
  background-color: #0056b3;
}

.backspace-button {
  background-color: #f44336;
}

.call-button {
  background-color: #4caf50;
}

/* Modal Styles */
.modal {
  display: flex; /* Ensure the modal is displayed */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  width: 30%;
  border-radius: 10px;
  text-align: center;
}

/* Call History Styles */
.call-history {
  display: flex; /* Ensure the call history is displayed */
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  margin-top: 20px;
}

.call-history ul {
  list-style-type: none;
  padding: 0;
}

.call-history li {
  display: flex;
  justify-content: space-between;
  margin: 5px 0;
}
</style>
