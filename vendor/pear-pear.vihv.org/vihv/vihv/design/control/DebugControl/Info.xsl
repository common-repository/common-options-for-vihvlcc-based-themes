<xsl:stylesheet version="1.0" encoding="UTF-8" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
	<xsl:template name="DebugControlInfo">
		<div id="DebugControl{Name}{RootTag}" name="DebugControlInfoItem" style="display:none;" class="item">
			<xsl:if test="Active = 'true'">
				<xsl:attribute name="class">item active</xsl:attribute>
			</xsl:if>
			<div>
				<xsl:value-of select="Name"/>
			</div>
			<div>
				Active: <xsl:value-of select="Active"/>
			</div>
			<div>
				<div>Events</div>
				<div>
					<xsl:for-each select="event/item">
						<xsl:value-of select="."/>&#160;
					</xsl:for-each>
				</div>
			</div>
			<div>
				<div>XML data</div>
				<div class="xml">
						<xsl:value-of select="xml" disable-output-escaping="yes"/>
					
				</div>
			</div>
		</div>
		<xsl:if test="Children">
			<xsl:for-each select="Children/item">
				<xsl:call-template name="DebugControlInfo"/>
			</xsl:for-each>
		</xsl:if>
	</xsl:template>
	
</xsl:stylesheet>
