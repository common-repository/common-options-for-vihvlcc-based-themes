<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="yes"/>
    <xsl:template match="vihv-Control">
        <html>a=<xsl:value-of select="a"/></html>
    </xsl:template>
</xsl:stylesheet>
