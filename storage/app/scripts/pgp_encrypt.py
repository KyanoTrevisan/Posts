import sys
import pgpy
import secrets

def encrypt_message(pubkey_text, message):
    # Load public key from text
    pubkey = pgpy.PGPKey()
    pubkey.parse(pubkey_text)
    # Encrypt a message with the public key
    encrypted_message = pubkey.encrypt(pgpy.PGPMessage.new(message))
    return str(encrypted_message)

if __name__ == "__main__":
    pubkey_text = sys.argv[1]
    message = sys.argv[2]
    print(encrypt_message(pubkey_text, message))
