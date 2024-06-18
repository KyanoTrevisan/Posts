# Markdown Guide

**Markdown** is a lightweight markup language that you can use to add formatting elements to plaintext text documents. Created by John Gruber in 2004, Markdown is now one of the world's most popular markup languages.

## Headers

To create a heading, add one to six `#` symbols before your heading text. The number of `#` symbols you use will determine the size of the heading.

Example:
```markdown
# This is a Heading 1
## This is a Heading 2
### This is a Heading 3
```

# This is a Heading 1
## This is a Heading 2
### This is a Heading 3

---

## Lists

### Unordered List

To create an unordered list, add dashes (`-`), asterisks (`*`), or plus signs (`+`) in front of line items.

Example:
```markdown
- Item 1
- Item 2
  - Item 2a
  - Item 2b
```

- Item 1
- Item 2
  - Item 2a
  - Item 2b

### Ordered List

To create an ordered list, add line items with numbers followed by periods.

Example:
```markdown
1. Item 1
2. Item 2
3. Item 3
```

1. Item 1
2. Item 2
3. Item 3

---

## Images

To add an image, use the following syntax:

Example:
```markdown
![Sample Image](https://via.placeholder.com/150 "Optional title")
```

![Sample Image](https://via.placeholder.com/150 "Optional title")

---

## Links

To create a link, enclose the link text in brackets (`[ ]`), and then follow it immediately with the URL in parentheses (`( )`).

Example:
```markdown
[Sooox](https://www.sooox.cc)
```


[Sooox](https://www.sooox.cc)

---

## Code

### Inline code

To denote a word or phrase as code, enclose it in backticks (` ` ).

Example:
```markdown
This web site is using `Markdown`.
```

This web site is using `Markdown`.


### Block code

To create a code block, either indent each line of the block by at least four spaces or one tab, or use triple backticks (```) before and after the block of code.

Example:
````markdown
```json
{
  "firstName": "John",
  "lastName": "Doe",
  "age": 25
}
```
````

```json
{
  "firstName": "John",
  "lastName": "Doe",
  "age": 25
}
```

---

## Blockquote

To create a blockquote, add a `>` in front of a paragraph.

Example:
```markdown
> This is a blockquote.
```
> This is a blockquote.
