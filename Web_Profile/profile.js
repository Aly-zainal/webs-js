const imgDiv = document.querySelector('hero');
const img = document.querySekector('#foto');
const file = document.querySelector('#input-file');
const Uploadbtn = document.querySelector('#Uploadbtn');

imgDiv.addEventListener('mouseenter', function(){
    Uploadbtn.style.display = "block";
});

imgDiv.addEventListener('mouseleave', function () {
    Uploadbtn.style.display = "none";
});

file.addEventListener('change', function(){
    const choosefile = this.file[0];

    if(choosefile) {
        const reader = new FileReader();
        reader.addEventListener('load', function(){
            img.setAttribute('src', reader.result);
    });
    
    reader.readAsDataURL(choosefile);
});



