<html>
<head>
    <title>Single page search</title>
    <script>
        var localHost = "<?php echo env('APP_URL'); ?>";

        function showResult(str) {
            if (str.length === 0) {
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = "0px";
                return false;
            }

            var objXMLHttpRequest = new XMLHttpRequest();
            objXMLHttpRequest.onreadystatechange = function () {
                if (objXMLHttpRequest.readyState === 4) {
                    if (objXMLHttpRequest.status === 200) {
                        document.getElementById("displayBlock").innerHTML = this.responseText;
                        document.getElementById("livesearch").style.border = "1px solid #FF6347";
                        document.getElementById("displayBlock").style.border = "1px solid #0000A0";
                    } else {
                        alert('Error Code: ' + objXMLHttpRequest.status);
                        alert('Error Message: ' + objXMLHttpRequest.statusText);
                    }
                }
            }
            objXMLHttpRequest.open('GET', localHost + "/names/" + str + "/1");
            objXMLHttpRequest.send();
        }
    </script>
</head>
<body>

<form>
    <input type="text" size="30" onkeyup="showResult(this.value)">
    <div id="livesearch"></div>
    <br><br>
    <span id="displayBlock"></span>
</form>

</body>
</html>
