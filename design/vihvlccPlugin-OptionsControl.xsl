<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="vihvlccPlugin-OptionsControl">
        <div class="vihvlccplugin">
            <h1 class="vihvlccplugin__title"><xsl:value-of select="//labels/pageTitle"/></h1>
            <div class="vihvlccplugin__header-message"><xsl:value-of select="//labels/headerMessage"/></div>
            <div class="vihvlccplugin__options-container">
                <form
                    class="vihvlccplugin__options-form" 
                    method="post">
                    <input type="hidden" name="forcePost" value="1"/>
                    <div class="vihvlccplugin__option-container vihvlccplugin__option-container__enable-debugger">
                        <input type="checkbox" name="debugger" class="vihvlccplugin__input__checkbox">
                            <xsl:if test="enableDebugger = '1'">
                                <xsl:attribute name="checked">checked</xsl:attribute>
                            </xsl:if>
                        </input>
                        <label for="debugger" class="vihvlccplugin__label"><xsl:value-of select="//labels/enableDebugger"/></label>
                    </div>
                    
                    <div class="vihvlccplugin__option-container">
                        <h2 class="vihvlccplugin__option-title">
                            <xsl:value-of select="//labels/debuggerPositionTitle"/>
                        </h2>
                        <div class="vihvlccplugin__radio-container">
                            <input type="radio" name="debuggerposition" value="0"
                            class="vihvlccplugin__input__radio"
                            >
                                <xsl:if test="debuggerPosition = '0'">
                                    <xsl:attribute name="checked">checked</xsl:attribute>
                                </xsl:if>
                            </input>
                            <div class="vihvlccplugin__position vihvlccplugin__position__bottom-right"/>
                            <div class="vihvlccplugin__clear"/>
                        </div>
                        <div class="vihvlccplugin__radio-container">
                            <input type="radio" name="debuggerposition" value="1"
                            class="vihvlccplugin__input__radio"
                            >
                                <xsl:if test="debuggerPosition = '1'">
                                    <xsl:attribute name="checked">checked</xsl:attribute>
                                </xsl:if>
                            </input>
                            <div class="vihvlccplugin__position vihvlccplugin__position__bottom-left"/>
                            <div class="vihvlccplugin__clear"/>
                        </div>
                    </div>
                    
                    <button class="vihvlccplugin__button__submit button button-primary"><xsl:value-of select="//labels/save"/></button>
                </form>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
