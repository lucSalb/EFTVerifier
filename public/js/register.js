let config = {
    fps: 50,
    qrbox: 350,
    rememberLastUsedCamera: false,
    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
  };
  
  let html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);
  html5QrcodeScanner.render(onScanSuccess);

  const html5QrCode = new Html5Qrcode(
    "reader", { formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ] });
  const qrCodeSuccessCallback = (decodedText, decodedResult) => {
      /* handle success */
  };  
  function onScanSuccess(decodedText, decodedResult) {
    console.log(`Code matched = ${decodedText}`, decodedResult);
    var smNo = document.getElementById('SMSeriesNo');
    CameraControl();
    smNo.value = decodedText;
  }
  function CameraControl() {
    var btn = document.getElementById('runBtn');
    var notReadingPanel = document.getElementById('notReading');
    var readingPanel = document.getElementById('reader');
    if (btn.classList.contains('running')) {
        // If the button is currently in 'running' state, switch to 'stopped' state
        btn.classList.remove('running');
        btn.innerText = "Start capture";
        notReadingPanel.removeAttribute('hidden');
        readingPanel.setAttribute('hidden', 'true');
        html5QrcodeScanner.clear();
    } 
    else {
        html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);
        html5QrcodeScanner.render(onScanSuccess);

        btn.innerText = "Stop capture";
        btn.classList.add('running');
        readingPanel.removeAttribute('hidden');
        notReadingPanel.setAttribute('hidden', 'true');
    }
 }