<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>PHPCS Overview</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
      </head>
      <body>
        <div class="container">
          <h4>PHPCS Violations</h4>
          <table class="table table-striped">
            <thead>
              <tr>
                <th><div align="center">File Name</div></th>
                <th><div align="center">Errors</div></th>
                <th><div align="center">Warnings</div></th>
              </tr>
            </thead>
            <tbody>
              <xsl:apply-templates select="phpcs/file"/>
              <tr>
                <td></td>
                <td><div class="text-right"><strong><xsl:value-of select="count(phpcs/file/error)"/></strong></div></td>
                <td><div class="text-right"><strong><xsl:value-of select="count(phpcs/file/warning)"/></strong></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="file">
    <tr>
      <td><xsl:value-of select="@name"/></td>
      <td><div class="text-right"><xsl:value-of select="@errors"/></div></td>
      <td><div class="text-right"><xsl:value-of select="@warnings"/></div></td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
