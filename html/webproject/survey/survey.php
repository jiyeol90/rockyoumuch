<html>
    <head>
        <title>설문조사</title>
        <link rel="stylesheet" type="text/css" href="../css/survey.css">
        <meta charset="utf-8">
        <script>
            function update() {
                var vote;
                var length = document.survey_form.composer.length;

                for(var i = 0; i < length; i++) {
                    if(document.survey_form.composer[i].checked==true) {
                        vote = document.survey_form.composer[i].value;
                        break;
                    }
                }

                if(i == length) {
                    alert("문항을 선택하세요");
                    return;
                }
                window.open("update.php?composer="+vote, "", "left=200, top=200, width=200, height=250, status=no, scrollbars=no");
                window.close();

            }

            function result() {
                window.open("result.php", "", "left=200, top=200, width=200, height=250, status=no, scrollbars=no, toolbars=no");
                window.close();
            }
        </script>
        </head>

        <body>
            <form name="survey_form" method="post">
                <table boarder="0" cellspacing="0" cellpadding="0" width="200" align="center">
                    <input type="hidden" name="kkk" value="100">
                    <tr height="40">
                        <td><img src="../img/bbs_poll.gif"></td>
                    </tr>
                    <tr height="1" bgcolor="#cccccc"><td></td></tr>
                    <tr height="7"><td></td></tr>
                    <tr><td><b> 가장 좋아하는 밴드 는?</b></td></tr>
                    <tr height="7"><td></td></tr>
                    <tr><td><input type="radio" name="composer" value="selection1"> 1. Lambs of God </td></tr>
                    <tr height="5"><td></td></tr>
                    <tr><td><input type="radio" name="composer" value="selection2"> 2. Nothing but Theives </td></tr>
                    <tr height="5"><td></td></tr>
                    <tr><td><input type="radio" name="composer" value="selection3"> 3. Tool </td></tr>
                    <tr height="5"><td></td></tr>
                    <tr><td><input type="radio" name="composer" value="selection4"> 4. Under Oath </td></tr>
                    <tr height="7"><td></td></tr>
                    <tr height="7"><td></td></tr>
                    <tr>
                        <td align="middle">
                            <img src="../img/b_vote.gif" border="0" style="cursor:hand" onclick="update()">
                            <img src="../img/b_result.gif" border="0" style="cursor:hand" onclick="result()">
                        </td>
                    </tr>
                </table>
        </form>
        </body>
</html>
                        