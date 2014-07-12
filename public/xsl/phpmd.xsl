<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>PHPMD</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
      </head>
      <body>
        <div class="container">
          <table class="table">
            <thead>
              <tr>
                <th><div align="center">Line</div></th>
                <th><div align="center">Violation</div></th>
                <th><div align="center">Priority</div></th>
              </tr>
            </thead>
            <tbody>
              <xsl:apply-templates select="pmd/file"/>
            </tbody>
          </table>
        </div>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="file">
    <td colspan="3"><xsl:value-of select="@name"/></td>
    <xsl:for-each select="violation">
          <tr>
            <td><div class="text-right"><xsl:value-of select="@beginline"/>-<xsl:value-of select="@endline"/></div></td>
            <td><xsl:value-of select="."/></td>
            <td><div class="text-right"><xsl:value-of select="@priority"/></div></td>
          </tr>
    </xsl:for-each>
  </xsl:template>
</xsl:stylesheet>

