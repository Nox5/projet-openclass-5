(function() {
    var fig = document.querySelectorAll("figure")[0];
    var posImg = fig.offsetTop;
    function effet(){
        var posCurseur = this.pageYOffset;
        if(posImg-posCurseur<300){
        fig.style.left = 0;
        fig.style.opacity = 1;
        }else{
        fig.style.left = "160%";
        fig.style.opacity = 0;
        }
    }
    window.addEventListener("scroll", effet);
}) ();