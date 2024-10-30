<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" encoding="utf-8" indent="no"/>
        <xsl:variable name="Schwaber">Кен Швабер</xsl:variable>
	<xsl:variable name="Mail">Ваш e-mail</xsl:variable>
	<xsl:variable name="Subject">Тема</xsl:variable>
	<xsl:variable name="Send">Отправить</xsl:variable>
	<xsl:variable name="MailSent">Ваше сообщение успешно отправлено</xsl:variable>
	<xsl:template match="TFeedbackControl">
            <div class="TMailControl">
            
		<xsl:if test="succeed">
			
		</xsl:if>
		<xsl:if test="not(succeed)">
                        <div class="MessageGood" id="TMailControlMessage" style="display:none;">
				<xsl:value-of select="$MailSent"/>
			</div>
		<table class="Mail" align="center">
		<form method="post">
			<tr>
				<td class="left"><xsl:value-of select="$Subject"/></td>
				<td>
					<input type="text" name="subject" size="70"/>
				</td>
			</tr>
			<tr>
				<td><xsl:value-of select="$Mail"/></td>
				<td>
					<input type="text" name="mail" size="70"/>
				</td>
			</tr>
			<tr>
				<td/>
				<td>
					<textarea name="content"/>
				</td>
			</tr>
			<tr>
				<td/>
				<td align="right">
					<input type="Submit" name="FeedbackSendClick" value="{$Send}"/>
				</td>
			</tr>
		</form>
		</table>

		</xsl:if>
                <script>
                   
                    if(window.location.hash == '#succeed') {
                        document.getElementById('TMailControlMessage').style.display = '';
                    }
                </script>
                </div>
	</xsl:template>
</xsl:stylesheet>