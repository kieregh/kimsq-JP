<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/foot.engine.php' ?>

<!-- Facebook and Path style side menus https://github.com/jakiestfu/Snap.js -->
<?php getImport('snap','snap.min',false,'js')?>

<script>
$(window).ready(function() { // DOM 객체만 로드 되자마자 바로바로 처리 됨
    $("#preloader").fadeOut(""); // will fade out the white DIV that covers the website.
})

// sidebar 관련
$(document).ready(function(){
    $('.rb-sidebar-close').click(function(){
        snapper.close();
    });
       
    var snapper = new Snap({
      element: document.getElementById('content-wrap'),
      // 왼쪽 사이드바 비활성
      disable: 'left'
    });
    $('.rb-sidebar-left-deploy').click(function(){
        if( snapper.state().state=="left" ){
            snapper.close();
        } else {
            snapper.open('left');
        }
        return false;
    });
    
    $('.rb-sidebar-right-deploy').click(function(){
        if( snapper.state().state=="right" ){
            snapper.close();
        } else {
            snapper.open('right');
        }
        return false;
    });
    document.getElementById('snap-drawer-search').addEventListener('focus', function(){
        snapper.expand('right');
    });
    document.getElementById('snap-drawer-search').addEventListener('blur', function(){
        snapper.open('right');
    });
});

// 대화상자 페이드아웃
$(".alert").delay(200).addClass("in").fadeOut(4000);
</script>
