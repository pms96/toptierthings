document.addEventListener('DOMContentLoaded', function() {
    var generateAmazon = document.getElementById("generateAmazon");

    generateAmazon.addEventListener("keyup", function () {
        var inputVal = generateAmazon.value;

        var code = '?&linkCode=ll1&tag=toptierthin0d-21&linkId=1e86ecd8f09b1617011aadb482d6a3da&language=es_ES&ref_=as_li_ss_tl';

        var result = inputVal+code;

        if ( inputVal != '' ) {
            document.getElementById("result").innerHTML = result;
            document.getElementById("generator").hidden = false;
            document.getElementById("generator").style.zIndex = "4";
        }else{
            document.getElementById("result").innerHTML = '';
            document.getElementById("generator").hidden = true;
            document.getElementById("generator").style.zIndex = "0";
        }
    });

    document.getElementById("cancelGenerate").addEventListener('click', function() {
        document.getElementById("result").innerHTML = '';
        document.getElementById("generator").hidden = true;
        document.getElementById("generator").style.zIndex = "0";
    });

    // Selecting all the DOM Elements that are necessary -->

    // The Viewbox where the result will be shown
    const resultEl = document.getElementById("result");

    // Button to copy the text
    const copyBtn = document.getElementById("copy-btn");
    // Result viewbox container
    const resultContainer = document.querySelector(".result");
    // Text info showed after generate button is clicked
    const copyInfo = document.querySelector(".result__info.right");
    // Text appear after copy button is clicked
    const copiedInfo = document.querySelector(".result__info.left");

    // if this variable is trye only then the copyBtn will appear, i.e. when the user first click generate the copyBth will interact.
    let generatedPassword = true;

    // This will update the position of the copy button based on mouse Position
    resultContainer.addEventListener("mousemove", e => {
        resultContainerBound = {
            left: resultContainer.getBoundingClientRect().left,
            top: resultContainer.getBoundingClientRect().top,
        };
        if(generatedPassword){
            copyBtn.style.opacity = '1';
            copyBtn.style.pointerEvents = 'all';
            copyBtn.style.setProperty("--x", `${e.x - resultContainerBound.left}px`);
            copyBtn.style.setProperty("--y", `${e.y - resultContainerBound.top}px`);
        }else{
            copyBtn.style.opacity = '0';
            copyBtn.style.pointerEvents = 'none';
        }
    });
    window.addEventListener("resize", e => {
        resultContainerBound = {
            left: resultContainer.getBoundingClientRect().left,
            top: resultContainer.getBoundingClientRect().top,
        };
    });

    // Copy Password in clipboard
    copyBtn.addEventListener("click", () => {
        const textarea = document.createElement("textarea");
        const password = resultEl.innerText;
        if (!password || password == "CLICK GENERATE") {
            return;
        }
        textarea.value = password;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        textarea.remove();

        copyInfo.style.transform = "translateY(200%)";
        copyInfo.style.opacity = "0";
        copiedInfo.style.transform = "translateY(0%)";
        copiedInfo.style.opacity = "0.75";
    });

});

function extractASIN(url) {

    const parts = url.split("/");
    const precedingIndex = parts.indexOf("dp");
  
    return parts[precedingIndex+1];
  }

function urlJustCopied ( ) {

    const url = document.getElementById("result").innerHTML;
    const code = extractASIN(url);

    const params = {
        'url':          url,
        'product_code': code,
    };

    $.ajax({
        type: 'POST',
        url: 'url-amazon',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:params,
        success:function(data){
            if ( data === '') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'success',
                    title: 'Correcto'
                })
            }else{
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                })
            }
        },
        error:function(){

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            
            Toast.fire({
                icon: 'error',
                title: 'Error'
            })

        }
     });

}