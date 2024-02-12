<div
    style="
    color: white;
background-color: #363535;
position: absolute;
bottom :0;
width: 100vw;
height:5vh;
display: flex;
justify-content: space-around;
align-items: center;
"
>
    <span>Debug Mode On</span>

    <span>
        <span>Auth :</span>
        <span>
            <?php
            if(\Core\Session\Session::userConnected()){
                echo \Core\Session\Session::user()['id']." : ".\Core\Session\Session::user()['username'];
            }else{
                echo "Anonymous";
            }
            ?>
        </span>
    </span>

    <span>
        <a style="list-style: none; text-decoration: none; color: white" href="http://localhost:4372" target="_blank" rel="nofollow"><strong>--> Profiler</strong></a>
    </span>

</div>