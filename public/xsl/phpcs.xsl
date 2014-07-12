<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>PHPCS</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
      </head>
      <body>
        <div class="container">
          <table class="table">
            <thead>
              <tr>
                <th><div align="center">Level</div></th>
                <th><div align="center">Line:Col</div></th>
                <th><div align="center">Violation</div></th>
                <th><div align="center">Rule</div></th>
              </tr>
            </thead>
            <tbody>
              <xsl:apply-templates select="phpcs/file"/>
            </tbody>
          </table>
        </div>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="file">
    <td colspan="4"><xsl:value-of select="@name"/></td>
    <xsl:for-each select="error|warning">
      <xsl:choose>
        <xsl:when test="name(.)='error'">
          <tr class="danger">
            <td>Error</td>
            <td><div class="text-right"><xsl:value-of select="@line"/>:<xsl:value-of select="@column"/></div></td>
            <td><xsl:value-of select="."/></td>
            <td><xsl:value-of select="@source"/></td>
          </tr>
        </xsl:when>
        <xsl:when test="name(.)='warning'">
          <tr class="warning">
            <td>Warning</td>
            <td><xsl:value-of select="@line"/>:<xsl:value-of select="column"/></td>
            <td><xsl:value-of select="."/></td>
            <td><xsl:value-of select="@source"/></td>
          </tr>
        </xsl:when>
      </xsl:choose>
    </xsl:for-each>
  </xsl:template>
</xsl:stylesheet>
