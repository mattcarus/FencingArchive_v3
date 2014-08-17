<?xml version="1.0"?>
<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xhtml="http://www.w3.org/1999/xhtml"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xs="http://www.w3.org/2001/XMLSchema">


    <xsl:output method="text" encoding="iso-8859-1"/>
    
    <xsl:strip-space elements="*" />
    
  	<xsl:template match="/*/*/*/child::*">
  		<xsl:for-each select="child::*">
			<xsl:if test="position() != last()">"<xsl:value-of select="translate(., '&#160;', '')"/>",</xsl:if>
			<xsl:if test="position()  = last()">"<xsl:value-of select="translate(., '&#160;', '')"/>"<xsl:text>&#xa;</xsl:text>
			</xsl:if>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>