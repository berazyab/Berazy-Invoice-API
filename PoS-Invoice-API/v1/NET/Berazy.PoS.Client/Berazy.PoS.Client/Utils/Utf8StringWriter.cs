using System.IO;
using System.Text;

namespace Berazy.PoS.Client.Utils {

    /// <summary>
    /// UTF-8 String Writer.
    /// </summary>
    public class Utf8StringWriter : StringWriter {
        public override Encoding Encoding {
            get { return Encoding.UTF8; }
        }
    }

}
