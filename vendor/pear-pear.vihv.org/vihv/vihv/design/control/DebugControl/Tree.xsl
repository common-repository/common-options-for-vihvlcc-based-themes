<xsl:stylesheet version="1.0" encoding="UTF-8" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
	<xsl:template name="DebugControlTree">
		<li>
			<xsl:if test="Active = 'true'">
				<xsl:attribute name="class">active</xsl:attribute>
			</xsl:if>
			<span onclick="DebugControlShowInfo('{Name}{RootTag}');">
			    <xsl:value-of select="Name"/>
			    <xsl:if test="not(Name=RootTag)">
				<small>
				    (<xsl:value-of select="RootTag"/>)
				</small>
			    </xsl:if>
			</span>
			<xsl:if test="Children">
				<ul>
				<xsl:for-each select="Children/item">
					<xsl:call-template name="DebugControlTree"/>
				</xsl:for-each>
				</ul>
			</xsl:if>
		</li>
	</xsl:template>
</xsl:stylesheet>
