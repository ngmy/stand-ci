<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>PHPCPD</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
      </head>
      <body>
        <div class="container">
          <table class="table">
            <thead>
              <tr>
                <th><div align="center">Line</div></th>
                <th><div align="center">File</div></th>
              </tr>
            </thead>
            <tbody>
              <xsl:apply-templates select="pmd-cpd/duplication"/>
            </tbody>
          </table>
        </div>
        <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?skin=sons-of-obsidian">//</script>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="duplication">
    <tr>
      <td colspan="2">Duplication (Files: <xsl:value-of select="count(file)"/>, Lines:<xsl:value-of select="@lines"/>, Tokens:<xsl:value-of select="@tokens"/>)</td>
    </tr>
    <xsl:for-each select="file">
      <tr>
        <td><div class="text-right"><xsl:value-of select="@line"/></div></td>
        <td><xsl:value-of select="@path"/></td>
      </tr>
    </xsl:for-each>
    <tr>
      <td colspan="2"><pre class="prettyprint lang-php linenums"><xsl:value-of select="codefragment"/></pre></td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
