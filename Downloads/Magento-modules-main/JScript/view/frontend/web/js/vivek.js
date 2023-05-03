console.log("working");
window.addEventListener('load',function(){
    document.getElementById('sampleBtn').addEventListener("click", function(){
        alert('Alert Message');
    });
    const btn = document.getElementById('sampleBtn');
    document.getElementById('sampleBtn').addEventListener("click", function(){
        btn.style.backgroundColor = 'green';
        btn.style.color = 'black';
    });
    document.getElementById('sampleBtn').addEventListener("click", function(){
        document.getElementById('fname').value =  "across the street.";
    });


});

