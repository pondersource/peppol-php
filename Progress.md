# design

The goal is a clear design with easily modifiable code. Each method/class must have a few functions as possible.

Thinking for 5 packages with the use of object-oriented python:

sender - receiver - sender_functions - receiver_functions - invoice

Invoice must implement as abstract to make its fields obvious. For now, we will handle the ubl as a simple object(not an XML file. So we don't need the XML librarie for this step). 

Initially, we will implement our application in a local network.

The Soap methods will be added probably at sender_functions - receiver_functions packages.

# Next step: Implement the basic architecture in python / continue the research
