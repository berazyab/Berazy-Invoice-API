namespace Berazy.PoS.Example.Utils.Ext {

    /// <summary>
    /// String extensions.
    /// </summary>
    internal static class StringExt {

        /// <summary>
        /// Whether or not the string is null, empty or
        /// consists of only whitespace.
        /// </summary>
        /// <param name="str"></param>
        public static bool IsEmpty(this string str) {
            return string.IsNullOrWhiteSpace(str);
        }

    }

}
