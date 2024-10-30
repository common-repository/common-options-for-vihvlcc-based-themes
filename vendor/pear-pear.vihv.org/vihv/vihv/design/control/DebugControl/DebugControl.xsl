<xsl:stylesheet version="1.0" encoding="UTF-8" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
	<xsl:template match="vihv-DebugControl">
		<!--link rel="stylesheet" type="text/css" href="style/css.php?DebugControl"/-->
		<div class="DebugControl">
			<div class="DebugControlToggler DebugControl__toggler__{position}" onclick="ToggleDebugControlVisibility('DebugControl', 'DebugControlTogglerArrow');">
				Developer's Eye <span id="DebugControlTogglerArrow">&#8593;</span>
			</div>
			<div id="DebugControl" style="display:none;">
			<table width="100%" style="height: 100%;" cellspacing="10" cellpadding="0">
				<tr>
				<xsl:for-each select="tree">
					<td class="left">
						<div class="dccontainer">
						<ul class="DebugControlTopUl">
							<xsl:call-template name="DebugControlTree"/>
						</ul>
						</div>
					</td>
					<td width="50%" class="right">
						<div class="dccontainer">
						<xsl:call-template name="DebugControlInfo"/>
						</div>
					</td>
				</xsl:for-each>
				</tr>
			</table>
			</div>
		</div>
		<!--script src="script/js.php?ToggleVisibility"/>
		<script src="script/js.php?DebugControl"/-->
	</xsl:template>
        
        <!--xsl:template name="DebugControlTree">
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
	</xsl:template-->
	<xsl:include href="Tree.xsl"/>
	<xsl:include href="Info.xsl"/>
</xsl:stylesheet>
