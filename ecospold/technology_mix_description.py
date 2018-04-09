'''
  encode and decode a technology mix description based on 7 technologies

  bit | technology
  ----+--------------------------
  0   | primary settler
  1   | bod removal
  2   | nitrification
  3   | denitrification
  4   | bio P removal
  5   | chem P removal
  6   | metals and other elements
  ----+--------------------------

  example: "1110001"
  means:
    treatment with primary settler,
    with bod removal,
    with nitrification,
    without denitrification,
    without bio P removal,
    without chem P removal,
    with metals and other elements,
'''

def encode(bit_array):
  pass

def decode(bit_string):
  pass
