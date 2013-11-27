using System;

namespace Berazy.PoS.Client.Utils.Ext {

    /// <summary>
    /// Object extensions.
    /// </summary>
    internal static class ObjectExt {

        /// <summary>
        /// Throws an ArgumentNullException if the given data item is null.
        /// </summary>
        /// <param name="data">The item to check for nullity.</param>
        public static void ThrowIfNull<T>(this T data) where T : class {
            if (data == null) {
                throw new ArgumentNullException();
            }
        }

        /// <summary>
        /// Throws an ArgumentNullException if the given data item is null.
        /// </summary>
        /// <param name="data">The item to check for nullity.</param>
        /// <param name="message">The exception message</param>
        public static void ThrowIfNull<T>(this T data, string message) {
            if (data == null) {
                throw new ArgumentNullException(message);
            }
        }

    }

}
