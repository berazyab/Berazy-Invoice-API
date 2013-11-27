using System.IO;
using System.Xml.Serialization;

namespace Berazy.PoS.Client.Utils {
    
    /// <summary>
    /// XML Helper functions.
    /// </summary>
    internal static class XmlUtils {

        /// <summary>
        /// Serialize an object to XML.
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="obj"></param>
        public static string Serialize<T>(T obj) {
            var serializer = new XmlSerializer(typeof(T));
            using (var writer = new Utf8StringWriter()) {
                serializer.Serialize(writer, obj);
                return writer.ToString();
            }
        }

        /// <summary>
        /// Deserialize a stream to an object.
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="stream"></param>
        public static T Deserialize<T>(StreamReader stream) {
            var serializer = new XmlSerializer(typeof(T));
            var retval = serializer.Deserialize(stream);
            return (T) retval;
        }

    }

}
