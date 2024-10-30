<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
	<xsl:template match="vihv-WpHeadControl">
	    <head>
		<title><xsl:value-of select="title"/></title>
		<link href="{favicon}" rel="shortcut icon"/>
		<xsl:value-of select="wphead" disable-output-escaping="yes"/>
		<!--link rel="stylesheet" type="text/css" href="{template_url}/style/combine.php?{cssoptions}"/-->
		<xsl:if test="//vihv-DebugControl">
		    <link rel="stylesheet" type="text/css" href="{template_url}/css/css.php?DebugControl"/>
		    <script src="{template_url}/js/js.php?ToggleVisibility"/>
		    <script src="{template_url}/js/js.php?DebugControl"/>
		</xsl:if>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    </head>
	</xsl:template>
</xsl:stylesheet>
