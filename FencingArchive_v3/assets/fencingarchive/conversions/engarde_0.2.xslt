<xsl:stylesheet version="2.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xhtml xsl xs">

<xsl:output method="text" encoding="iso-8859-1" xpath-default-namespace="http://www.w3.org/1999/xhtml" />

<xsl:strip-space elements="*" />

<xsl:template match="//table[@class='liste']/child::*">
	<xsl:for-each select="*/*/child::*">
		<xsl:if test="position() != last()">"<xsl:value-of select="translate(., '&#160;', '')"/>",</xsl:if>
		<xsl:if test="position()  = last()">"<xsl:value-of select="translate(., '&#160;', '')"/>"
			<xsl:text>&#xa;</xsl:text>
		</xsl:if>
	</xsl:for-each>
</xsl:template>

</xsl:stylesheet>