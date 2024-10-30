<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
	<xsl:template match="vihv-ExceptionControl">
		<html>
		<head>
                    <style>
                        .exception {
                            margin: 150px;
                            background: #dee;
                            padding: 50px;
                            font-family: sans-serif;
                            font-size: 14px;
                        }
                        .exception>h1 {
                            font-size: 19.796px;
                            font-weight: normal;
                        }
                    </style>
			<link rel="shortcut icon" href="images/shortcut.png"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<title>Vihv LCC</title>
		</head>
		<body>
			<div class="exception">
                            <h1>Exception:</h1>
				<span class="class"><xsl:value-of select="class"/></span>&#160;
				<span class="message"><xsl:value-of select="message"/></span>
				<br/><br/>
				<div>
				<small><xsl:value-of select="full"/></small>
				</div>
				<br/><br/>
				<a href="">Reload this page,</a>&#160;<a href="index.php">view home page.</a>
			</div>
		</body>
		</html>
	</xsl:template>
</xsl:stylesheet>