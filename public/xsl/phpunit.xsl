<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>Tests</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
      </head>
      <body>
        <div class="container">
          <table class="table">
            <thead>
              <tr>
                <th><div align="center">Name</div></th>
                <th><div align="center">Status</div></th>
                <th><div align="center">Time (s)</div></th>
              </tr>
            </thead>
            <tbody>
              <xsl:apply-templates select="testsuites/testsuite/testsuite"/>
            </tbody>
          </table>
        </div>
      </body>
      <script src="//code.jquery.com/jquery-1.11.0.min.js">//</script>
      <script>
        $(function () {
          $('a').click(function () {
            var detail = $(this).closest('tr').next('tr');
            if (detail.css('display') === 'none') {
              detail.show();
            } else {
              detail.hide();
            }
          });
        });
      </script>
    </html>
  </xsl:template>
  <xsl:template match="testsuite">
    <td colspan="3"><xsl:value-of select="@name"/></td>
    <xsl:for-each select="testcase">
      <xsl:choose>
        <xsl:when test="failure">
          <tr class="danger">
            <td><xsl:value-of select="@name"/></td>
            <td><a href="javascript:void(0)">Failure &#187;</a></td>
            <td><div class="text-right"><xsl:value-of select="@time"/></div></td>
          </tr>
          <tr class="danger" style="display:none;">
            <td colspan="3"><xsl:call-template name="replace"><xsl:with-param name="str" select="failure"/></xsl:call-template></td>
          </tr>
        </xsl:when>
        <xsl:when test="error">
          <tr class="danger">
            <td><xsl:value-of select="@name"/></td>
            <td><a href="javascript:void(0)">Error &#187;</a></td>
            <td><div class="text-right"><xsl:value-of select="@time"/></div></td>
          </tr>
          <tr class="danger" style="display:none;">
            <td colspan="3"><xsl:call-template name="replace"><xsl:with-param name="str" select="error"/></xsl:call-template></td>
          </tr>
        </xsl:when>
        <xsl:otherwise>
          <tr class="success">
            <td><xsl:value-of select="@name"/></td>
            <td>Success</td>
            <td><div class="text-right"><xsl:value-of select="@time"/></div></td>
          </tr>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:for-each>
  </xsl:template>
  <xsl:template name="replace">
    <xsl:param name="str"/>
    <xsl:choose>
      <xsl:when test="contains($str, '&#10;')">
        <xsl:value-of select="substring-before($str, '&#10;')"/><br/>
        <xsl:call-template name="replace">
          <xsl:with-param name="str" select="substring-after($str, '&#10;')"/>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$str"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
</xsl:stylesheet>
